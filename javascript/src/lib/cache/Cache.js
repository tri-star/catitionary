/**
 * @property {int} ttl 有効期限(ミリ秒)
 */
export class Cache {
  constructor(ttl) {
    this.lastCalled = null
    this.cachedValue = null
  }

  /**
   * @param {Number} ttl 有効期限(ミリ秒)
   * @param {Function} callback 値を更新する時に実行する関数
   */
  async get(ttl, callback) {
    const d = new Date()
    const currentTime = d.getTime()
    const expiration = this.lastCalled + ttl
    if (this.lastCalled && currentTime < expiration) {
      return this.cachedValue
    }

    this.lastCalled = currentTime
    this.cachedValue = await callback()
    return this.cachedValue
  }
}
