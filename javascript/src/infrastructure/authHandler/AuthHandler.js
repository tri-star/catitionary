// import { UserRepository, UserRepositoryKey } from './UserRepository'

export class AuthHandler {
  constructor(userRepository) {
    this.userRepository = userRepository
  }

  /**
   *
   * @param {String} loginId
   * @param {String} password
   * @returns
   */
  async login(loginId, password) {
    if (password.length === 0) {
      return false
    }

    const user = await this.userRepository.fetchUser(loginId)

    if (user === null) {
      return false
    }

    localStorage.setItem('loginId', user.loginId)
    return true
  }

  async logout() {
    localStorage.removeItem('loginId')
  }

  async getUser() {
    const loginId = localStorage.getItem('loginId')
    if (loginId === null) {
      return null
    }

    const user = await this.userRepository.fetchUser(loginId)
    return user
  }
}
