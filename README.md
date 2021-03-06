# Catitionary

## 概要

猫の名前を収集、データベース化し自動生成などの機能を提供するサービスです。

設計(フロント/バックエンド)や Javascript -> Typescript 移行の実験に使用する目的もあります。

### API

開発初期時点では以下の API を REST API で提供することを目指しています。

- 猫の名前の自動生成(指定された特徴などから生成)
- 名前の案、パターンのリクエストの受け付け(例： 末尾が"吉"、"茶"で始まるなど)

## 環境構築方法

TODO

## 設計

### バックエンド

以下の記事を参考に、テスタビリティを確保しつつレイヤーが複雑にならない Laravel アプリケーションの構成を検討します。
https://zenn.dev/mpyw/articles/ce7d09eb6d8117

- DB は常に使えるものと考え、モックしない

  - Eloquent モデルと QueryBuilder クラスで DB 操作処理の共通化を図る
  - 後述する Entity が必要なケースでは Repository を設ける
  - テストにおいても Eloquent モデルを扱いながらテストする

- Eloquent モデル、Entity(テーブルと紐づかない) もどちらもモデルと考えて Domain 層に配置する

  - Entity を用意しても結局はテーブルと同じ構造を持つことになる場合は Eloquent モデルをそのまま使用する
  - モデルを永続化しようとした時にテーブルの構造と一致しない場合は Entity を用意することを検討する
  - バリューオブジェクトは必要に応じて用意する

- 実物に近い実装を用意できない外部 API への依存は DI により差し替え可能にする(インターフェースを設ける)

  - ただし、実物に近いものを用意できる場合はそちらを使用する
    (モックよりも実際に近い動作をする代替のものが用意出来る場合はそちらを優先する)

- Controller/Command/Job で実行する処理の本体は UseCase に記述する

  - 主な処理を UseCase に記述することで粒度を揃え、UseCase のクラス一覧を確認することで
    どのような処理があるか把握できるようにする
  - なるべく HTTP などの詳細に依存しないように実装するが、1 つの UseCase を HTTP 経由/CLI 経由などで
    共有することに無理がある場合は無理に再利用しない
  - UseCase 間でも共通化させたいロジックは SubUseCase を定義して共有するか、Service クラスを作成する。
    (Service クラスは XXXService のような名前ではなく処理名がクラス名になる。Domain 層に配置する)

### API

- Open API 関連のツールを使用し API 仕様書を管理
- フロントエンド側は Prism のモックサーバーを使用しながら開発

### フロントエンド

初期は Javascript + Vue2.6 + Composition API で開発し、途中から TypeScript + Vue3 に移行する。
(移行を試したいため)

- Laravel が提供する Vue.js との連携機能は利用せず、純粋に Javascript のアプリケーションとして動作するようにする
  (フロントエンドとバックエンドを切り離しやすくするため。)
- Vuex は使用せず、コンポーネント内のロジックは Hook として切り出す。
- 依存関係の注入の方法として provide / inject を利用する。

## 命名規則

### バックエンド

フレームワークの制約など特別な事情がある場合を除いては以下の形とします。
(例： Eloquent モデルを使用する場合、メンバ変数名に DB カラムが含まれるため snake_case を使用することがあり得ます)

| 要素           | ケース        | 備考 |
| -------------- | ------------- | ---- |
| ネームスペース | PascalCase    |
| クラス         | PascalCase    |
| メソッド/関数  | camelCase     |
| メンバ変数     | camelCase     |
| 定数           | CONSTANT_CASE |
| 連想配列       | snake_case    |

### フロントエンド

フレームワークの制約など特別な事情がある場合を除いては以下の形とします。

| 要素                | ケース        | 備考                 |
| ------------------- | ------------- | -------------------- |
| クラス/オブジェクト | PascalCase    | コンポーネントも含む |
| メソッド/関数       | camelCase     |
| メンバ変数          | camelCase     |
| 定数                | CONSTANT_CASE |
| JSON のキー         | snake_case    |

ファイル名に関する規則

| 要素     | ケース                 | 備考                                                                                                 |
| -------- | ---------------------- | ---------------------------------------------------------------------------------------------------- |
| ファイル | PascalCase / camelCase | export するものの内容に合わせる。<br/>複数 export するものが存在する場合は主なものの名前を基準とする |
| フォルダ | camelCase              |
