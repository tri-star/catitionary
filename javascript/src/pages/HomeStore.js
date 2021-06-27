import { reactive } from '@vue/composition-api'

export class HomeStore {
  constructor(catRepository) {
    this.state = reactive({
      typeList: [],
      charactericsList: [],
    })
    this.catRepository = catRepository
  }

  async loadMenuList() {
    ;[this.state.typeList, this.state.charactericsList] = await Promise.all([
      this.catRepository.getTypeList(),
      this.catRepository.getCharactericsList(),
    ])
  }
}
