export class ApiError {
  /**
   * @param {string} message
   * @param {string?} code
   * @param {Record<string, string>?} details
   */
  constructor(message, code, details) {
    this.message = message
    this.code = code ?? ''
    this.details = details ?? {}
  }
}
