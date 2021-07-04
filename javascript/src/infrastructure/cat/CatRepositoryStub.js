export class CatRepositoryStub {
  constructor() {
    this.typeList = []
    this.charactericsList = []
  }

  async getTypeList() {
    return this.typeList
  }

  async getCharactericsList() {
    return this.charactericsList
  }
}
