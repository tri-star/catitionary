import { authHandlerKey } from '@/domain/user/authHandlerInterface'
import { catRepositoryKey } from '@/domain/cat/catRepositoryInterface'
import { CatRepository } from '@/infrastructure/cat/CatRepository'
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
        const axios = this.get('axios')
        return new UserRepository(axios)
      },
      [authHandlerKey]: () => {
        const userRepository = this.get(userRepositoryKey)
        const axios = this.get('axios')
        return new AuthHandler(userRepository, axios)
      },
      [catRepositoryKey]: () => {
        const axios = this.get('axios')
        return new CatRepository(axios)
      },
      axios: () => {
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
        return axios
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
