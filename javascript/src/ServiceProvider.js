import { authHandlerKey } from '@/domain/user/authHandlerInterface'
import { AuthHandler } from '@/infrastructure/authHandler/AuthHandler'
import { userRepositoryKey } from '@/domain/user/userRepositoryInterface'
import { UserRepository } from '@/infrastructure/user/UserRepository'
import _mapValues from 'lodash/mapValues'
import axios from 'axios'

export class ServiceProvider {
  constructor() {
    this.services = {}
  }

  register() {
    this.services = {
      [userRepositoryKey]: () => {
        return new UserRepository()
      },
      [authHandlerKey]: () => {
        const userRepository = this.get(userRepositoryKey)
        return new AuthHandler(userRepository)
      },
    }
  }

  boot() {
    return _mapValues(this.services, (initializer) => {
      return initializer()
    })
  }

  get(serviceName) {
    if (!this.services[serviceName]) {
      throw new Error(`無効なサービスが指定されました: ${serviceName}`)
    }
    return this.services[serviceName]()
  }
}
