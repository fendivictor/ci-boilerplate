const path = require('path');

module.exports = {
    entry: {
        addProject: ['./assets/js/apps/project/add.js']
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'dist/js')
    }
}