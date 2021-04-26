module.exports = {
  presets: [
    ['@babel/preset-env', { targets: '> 1%, last 2 versions, not dead' }],
  ],
  plugins: [
    [
      'inline-dotenv',
      {
        path: './.env',
      },
    ],
  ],
}
