const path = require("path");

module.exports = {
  watch: false,
  mode: "development",
  entry: {
    "a/a578a8g": path.resolve(__dirname, "src/auth/auth.ts"),
    "d/du48gn1": path.resolve(__dirname, "src/dashboard/user.ts"),
    "d/da48gn2": path.resolve(__dirname, "src/dashboard/dev.ts"),
    "d/dm48gfz": path.resolve(__dirname, "src/dashboard/menu.ts"),
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name].js",
  },
  resolve: {
    extensions: [".ts", ".js"], // Resolve TypeScript and JavaScript files
  },
  module: {
    rules: [
      {
        test: /\.ts$/,
        use: "ts-loader",
        exclude: /node_modules/,
      },
    ],
  },
};
