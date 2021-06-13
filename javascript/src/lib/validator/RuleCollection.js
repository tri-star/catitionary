export class RuleCollection {
  constructor(collection) {
    this.collection = collection ?? {}
  }

  getRules() {
    return this.collection
  }

  addRule(field, rule) {
    if (this.collection[field] === undefined) {
      this.collection[field] = {}
    }
    this.collection[field][rule.name ?? 'default'] = rule
  }

  addRules(field, rules) {
    if (this.collection[field] === undefined) {
      this.collection[field] = {}
    }
    rules.forEach((rule) => {
      this.collection[field][rule.name ?? 'default'] = rule
    })
  }

  removeRule(field, ruleName) {
    if (ruleName === undefined) {
      delete this.collection[field]
      return
    }
    delete this.collection[field][ruleName]
  }
}
