import { Endpoints } from '@/constants/Endpoints'
import { CatCharacterics } from '@/domain/cat/CatCharacterics'
import { CatType } from '@/domain/cat/CatType'
import { ServerSideError } from '@/errors/ServerSideError'

export class CatRepository {
  constructor(axios) {
    this.axios = axios
  }

  async getTypeList() {
    try {
      const response = await this.axios.get(Endpoints.cat.types)

      const typeList = []
      for (const row of response.data) {
        typeList.push(new CatType(row.id, row.name))
      }
      return typeList
    } catch (e) {
      throw new ServerSideError(e.message)
    }
  }

  async getCharactericsList() {
    try {
      const response = await this.axios.get(Endpoints.cat.characterics)

      const charactericsList = []
      for (const row of response.data) {
        charactericsList.push(new CatCharacterics(row.id, row.name))
      }
      return charactericsList
    } catch (e) {
      throw new ServerSideError(e.message)
    }
  }
}
