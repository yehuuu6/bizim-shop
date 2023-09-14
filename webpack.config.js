const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");

module.exports = {
  entry: {
    "auth/a578a8g": path.resolve(__dirname, "src/auth/index.ts"),
    "cart/5a8a8g": path.resolve(__dirname, "src/cart/index.ts"),
    "products/g5120x": path.resolve(__dirname, "src/products/index.ts"),
    "dashboard/du48gn1": path.resolve(__dirname, "src/dashboard/index.ts"),
    "profile/eb23ax4": path.resolve(__dirname, "src/profile/index.ts"),
    "core/dr50hzx": path.resolve(__dirname, "src/core.ts"),
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name].js",
  },
  resolve: {
    extensions: [".ts", ".js"],
  },
  module: {
    rules: [
      {
        test: /\.ts$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
      {
        test: /\.css$/,
        use: [MiniCssExtractPlugin.loader, { loader: "css-loader" }],
      },
      {
        test: /\.(png|jpg|gif|svg)$/,
        type: "asset/resource",
        generator: {
          filename: "imgs/[name].[hash][ext]",
        },
      },
    ],
  },
  optimization: {
    minimizer: [
      new TerserPlugin(),
      new CssMinimizerPlugin(),
      new ImageMinimizerPlugin({
        minimizer: {
          implementation: ImageMinimizerPlugin.sharpMinify,
          options: {
            encodeOptions: {
              jpeg: {
                quality: 75,
              },
              webp: {
                lossless: true,
              },
              avif: {
                lossless: true,
              },
            },
          },
        },
      }),
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "[name].css",
    }),
  ],
};
