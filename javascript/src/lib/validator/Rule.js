export class Rule {
  constructor(func, options) {
    this.func = func
    this.isAsync = options.isAsync ?? false
    this.onlyChanged = options.onlyChanged ?? false
    this.name = options.name ?? null
    this.target = options.target ?? null
  }
}
