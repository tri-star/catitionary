import { reactive } from '@vue/composition-api'
import { useApi } from '@/hooks/useApi'

export class HomeStore {
  constructor(catRepository, nameRepository) {
    this.state = reactive({
      typeList: [],
      charactericsList: [],
      checkedTypes: [],
      checkedCharacterics: [],
      submitted: false,
      names: [],
    })
    this.catRepository = catRepository
    this.nameRepository = nameRepository
    this.generateNamesHandler = useApi(async () => {
      return await this.nameRepository.generateNames(
        this.state.checkedTypes,
        this.state.checkedCharacterics
      )
    })
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

  async handleGenerateNamesClick() {
    this.state.submitted = true
    const result = await this.generateNamesHandler.execute()
    if (this.generateNamesHandler.isDone()) {
      this.state.submitted = false
      this.state.names = [...result]
    }
    if (this.generateNamesHandler.isError()) {
      this.state.submitted = false
      this.state.names = []
    }
  }
}
