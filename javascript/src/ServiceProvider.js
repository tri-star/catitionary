import { authHandlerKey } from '@/domain/user/authHandlerInterface'
import { AuthHandler } from '@/infrastructure/authHandler/AuthHandler'
import { userRepositoryKey } from '@/domain/user/userRepositoryInterface'
import { UserRepository } from '@/infrastructure/user/UserRepository'

export class ServiceProvider {
  static boot() {
    return {
      [userRepositoryKey]: new UserRepository(),
      [authHandlerKey]: new AuthHandler(new UserRepository()),
    }
  }
}
