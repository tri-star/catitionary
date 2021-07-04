import { Endpoints } from '@/constants/Endpoints'
import { Name } from '@/domain/name/Name'
import { ServerSideError } from '@/errors/ServerSideError'

export class NameRepository {
  constructor(axios) {
    this.axios = axios
  }

  async generateNames(types, characterics, count) {
    try {
      const params = {
        types,
        characterics,
        count,
      }
      // const response = await this.axios.get(Endpoints.name.generateNames, {
      //   params,
      // })

      const sleep = (msec) => {
        return new Promise((resolve) => {
          setTimeout(() => {
            resolve()
          }, msec)
        })
      }
      await sleep(800)

      const nameList = [
        new Name('kazukichi', 'かずきち'),
        new Name('nihei', 'にへい'),
        new Name('kumazou', 'くまぞう'),
        new Name('shirou', 'しろう'),
      ]
      return nameList
    } catch (e) {
      throw new ServerSideError(e.message)
    }
  }
}
