import { UserRepository } from '@/infrastructure/user/UserRepository'
import { AuthHandler } from '@/infrastructure/authHandler/AuthHandler'

export class ServiceProvider {
  static boot() {
    return {
      UserRepository: new UserRepository(),
      AuthHandler: new AuthHandler(new UserRepository()),
    }
  }
}
