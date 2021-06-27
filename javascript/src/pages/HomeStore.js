import { reactive } from '@vue/composition-api'

export class HomeStore {
  constructor(catRepository) {
    this.state = reactive({
      typeList: [],
      charactericsList: [],
      checkedTypes: [],
      checkedCharacterics: [],
    })
    this.catRepository = catRepository
  }

  async loadMenuList() {
    ;[this.state.typeList, this.state.charactericsList] = await Promise.all([
      this.catRepository.getTypeList(),
      this.catRepository.getCharactericsList(),
    ])
  }

  handleTypeChange(newCheckedItemIds) {
    this.state.checkedTypes = newCheckedItemIds
  }

  handleCharactericsChange(newCheckedItemIds) {
    this.state.checkedCharacterics = newCheckedItemIds
  }
}
