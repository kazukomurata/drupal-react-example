const path = require('path');

module.exports = {
  //エントリポイント（入力ファイル）
  entry: './es/app.js',
  //出力先
  output: {
    filename: 'app.js',
    path: path.resolve(__dirname, 'js'),
  },
  module: {
    rules: [
      {
        // Babel のローダーの設定
        //対象のファイルの拡張子
        test: /\.(js|mjs|jsx)$/,
        //対象外とするフォルダ
        exclude: /node_modules/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: [
                '@babel/preset-env',
                '@babel/preset-react',
              ]
            }
          }
        ]
      }
    ]
  },
};
