import _get from 'lodash/get'
import _cloneDeep from 'lodash/cloneDeep'
import { Rule } from './Rule'

function isConstraintFunction(arg) {
  return typeof arg === 'function'
}
function isConstraintObject(arg) {
  return arg instanceof Rule
}

export class ValidationContext {
  constructor(prevValue, userData = {}) {
    this.prevValue = prevValue
    this.userData = userData
  }

  /**
   * 1回前のバリデーション時の値が変化したかどうか
   * @param {*} currentValue 今回の値
   * @returns {boolean}
   */
  isChanged(currentValue) {
    return currentValue === this.prevValue
  }

  getUserData() {
    return this.userData
  }
}

export class ValidationResult {
  constructor(messages) {
    this.messages = []
    if (messages) {
      this.messages = messages
    } else {
      this.messages = {}
    }
  }

  add(name, messages) {
    if (!this.messages[name]) {
      this.messages[name] = []
    }
    messages.forEach((message) => {
      this.messages[name].push(message)
    })
  }

  getAll() {
    return this.messages
  }

  getMessages(name) {
    if (!this.messages[name]) {
      return []
    }
    return this.messages[name]
  }

  getFirst(name) {
    return this.messages[name][0]
  }

  isError() {
    return Object.keys(this.messages).length > 0
  }

  hasError(name) {
    return this.messages[name] ? true : false
  }
}

export class Validator {
  constructor(initialData) {
    this.initialData = _cloneDeep(initialData) ?? {}
    this.prevData = _cloneDeep(initialData) ?? {}
    this.dirtyFlags = {}
    this.prevResult = {}
  }

  setInitialData(initialData) {
    this.initialData = _cloneDeep(initialData) ?? {}
    this.prevData = _cloneDeep(initialData) ?? {}
    this.dirtyFlags = {}
    this.prevResult = {}
  }

  async validate(input, collection, force, userContext = null) {
    const rules = collection.getRules()
    const result = new ValidationResult()
    let r
    let initialValue
    let value
    let rule
    let target
    let parameters = {}

    for (const field in rules) {
      initialValue = _get(this.initialData, field, undefined)
      value = _get(input, field)
      if (!force) {
        if (!this.isDirty(field) && value === initialValue) {
          continue
        }
      }
      this.setDirty(field)

      for (const ruleName in rules[field]) {
        const context = new ValidationContext(
          _get(this.prevData, field),
          userContext
        )
        rule = rules[field][ruleName]

        // 前回のバリデーションから入力値に変化がない場合スキップするケースでは
        // 前回のバリデーション結果をそのまま採用する
        // (HTTPリクエストを伴うバリデーションなどが該当する)
        if (
          isConstraintObject(rule) &&
          rule.onlyChanged &&
          this.prevData[field] === input[field]
        ) {
          const prev = this.getPrevResult(field, ruleName)
          target = rule.target ?? field
          if (!prev.ok && prev.message) {
            result.add(target, [prev.message])
          }
          continue
        }

        if (isConstraintFunction(rule)) {
          r = rule(value, parameters, input, context)
          target = field
        } else if (isConstraintObject(rule) && !rule.isAsync) {
          r = rule.func(value, parameters, input, context)
          target = rule.target ?? field
          parameters = rule.parameters ?? {}
        } else if (isConstraintObject(rule) && rule.isAsync) {
          r = await rule.func(value, parameters, input, context)
          target = rule.target ?? field
          parameters = rule.parameters ?? {}
        } else {
          throw new Error(`無効なルールが指定されました: ${ruleName}`)
        }
        this.setPrevResult(field, ruleName, r.ok, r.message)

        if (!r.ok && r.message) {
          result.add(target, [r.message])
        }
      }
      this.prevData[field] = input[field]
    }

    return result
  }

  isDirty(field) {
    return (
      this.dirtyFlags[field] !== undefined && this.dirtyFlags[field] === true
    )
  }

  setDirty(field) {
    this.dirtyFlags[field] = true
  }

  setPrevResult(field, ruleName, result, message) {
    const key = `${field}__${ruleName}`
    this.prevResult[key] = {
      ok: result,
      message: message,
    }
  }

  getPrevResult(field, ruleName) {
    const key = `${field}__${ruleName}`
    return this.prevResult[key]
  }
}
