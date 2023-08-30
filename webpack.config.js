const path = require("path");

module.exports = {
  watch: false,
  mode: "development",
  entry: {
    "a/a578a8g": path.resolve(__dirname, "src/auth/auth.js"),
    "d/du48gn1": path.resolve(__dirname, "src/dashboard/user.js"),
    "d/da48gn2": path.resolve(__dirname, "src/dashboard/dev.js"),
  },
  output: {
    path: path.resolve(__dirname, "dist"),
    filename: "[name].js",
  },
};
