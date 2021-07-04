import { CatCharacterics } from '@/domain/cat/CatCharacterics'
import { CatType } from '@/domain/cat/CatType'
import { CatRepositoryStub } from '@/infrastructure/cat/CatRepositoryStub'
import { HomeStore } from '../HomeStore'

describe('HomeStore', () => {
  let store = null
  let catRepository = null

  beforeEach(() => {
    catRepository = new CatRepositoryStub()
    store = new HomeStore(catRepository)
  })

  it('初期状態', () => {
    expect(store.state.typeList).toStrictEqual([])
    expect(store.state.charactericsList).toStrictEqual([])
  })

  it('リストのロード完了後', async () => {
    const expectedTypeList = [
      new CatType('type-id-1', 'type-name-1'),
      new CatType('type-id-2', 'type-name-2'),
    ]
    const expectedCharacterList = [
      new CatCharacterics('character-id-1', 'character-name-1'),
      new CatCharacterics('character-id-2', 'character-name-2'),
    ]

    catRepository.typeList = expectedTypeList
    catRepository.charactericsList = expectedCharacterList
    await store.loadMenuList()
    expect(store.state.typeList).toStrictEqual(expectedTypeList)
    expect(store.state.charactericsList).toStrictEqual(expectedCharacterList)
  })
})
