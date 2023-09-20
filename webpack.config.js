const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");

module.exports = {
  entry: {
    "panels/2j4k6s8o9t1a3v5w7y0u": path.resolve(
      __dirname,
      "src/common/controllers/panel/menuController.ts"
    ),
    "panels/4s9k5f7p3o8t2a0v1w6u": path.resolve(
      __dirname,
      "src/common/controllers/panel/themeController.ts"
    ),
    "auth/rs5f0f0e1h08v35w6a2u3": path.resolve(__dirname, "src/auth/index.ts"),
    "cart/v8x3q6t9j2s5f0e1n7z4": path.resolve(
      __dirname,
      "src/shop/cart/index.ts"
    ),
    "product-page/9k25c1l2zki6a0e1n7q6": path.resolve(
      __dirname,
      "src/shop/productPage/index.ts"
    ),
    "products/m1l5d9y6b3r2n7o8c0s": path.resolve(
      __dirname,
      "src/shop/productsPage/index.ts"
    ),
    "dashboard/p2w4z9o5y8v3q6i1r7": path.resolve(
      __dirname,
      "src/dashboard/index.ts"
    ),
    "account/k7u4h0g3t5s9e1c6q2": path.resolve(
      __dirname,
      "src/account/index.ts"
    ),
    "core/r9k2p4i7h0o1g5w6a2u3": path.resolve(__dirname, "src/core.ts"),
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name].js",
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
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
                quality: 70,
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
