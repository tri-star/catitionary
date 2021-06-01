import _get from 'lodash/get'
import _cloneDeep from 'lodash/cloneDeep'

function isConstraintFunction(arg) {
  return typeof arg === 'function'
}
function isConstraintObject(arg) {
  return arg.rule !== undefined || arg.asyncRule !== undefined
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
    this.dirtyFlags = {}
  }

  setInitialData(initialData) {
    this.initialData = _cloneDeep(initialData) ?? {}
    this.dirtyFlags = {}
  }

  async validate(input, collection, force, context) {
    const result = new ValidationResult()

    const rules = collection.getRules()
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
        rule = rules[field][ruleName]
        if (isConstraintFunction(rule)) {
          r = rule(value, parameters, input, context ?? {})
          target = field
        } else if (isConstraintObject(rule) && rule.rule) {
          r = rule.rule(value, parameters, input, context ?? {})
          target = rule.target ?? field
          parameters = rule.parameters ?? {}
        } else if (isConstraintObject(rule) && rule.asyncRule) {
          r = await rule.asyncRule(value, parameters, input, context ?? {})
          target = rule.target ?? field
          parameters = rule.parameters ?? {}
        } else {
          throw new Error(`無効なルールが指定されました: ${ruleName}`)
        }
        if (!r.ok && r.message) {
          result.add(target, [r.message])
        }
      }
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
}
