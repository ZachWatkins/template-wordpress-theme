module.exports = {
    extends: ['eslint:recommended', 'plugin:prettier/recommended', 'plugin:jsdoc/recommended'],
    plugins: ['html', 'prettier', 'jsdoc'],
    env: {
        browser: true,
        commonjs: true,
        node: true,
        es2021: true,
        es2015: true,
        es6: true,
    },
    parser: '@babel/eslint-parser',
    parserOptions: {
        requireConfigFile: false,
        ecmaVersion: 2015,
        sourceType: 'module',
        ecmaFeatures: {
            jsx: true,
        },
    },
    ignorePatterns: ['node_modules', 'build', 'dist', 'public'],
    rules: {
        indent: ['error', 4],
        quotes: [
            'error',
            'single',
            {
                avoidEscape: true,
                allowTemplateLiterals: true,
            },
        ],
        'no-console': 0,
        semi: ['error', 'always'],
        'prefer-const': [
            'error',
            {
                destructuring: 'all',
            },
        ],
        'no-multi-spaces': ['error'],
        'no-unused-vars': [
            1,
            {
                ignoreRestSiblings: true,
            },
        ],
        'space-before-function-paren': 1,
        'jsdoc/check-types': 1,
        'jsdoc/no-types': 1,
        'prettier/prettier': [
            'error',
            {
                tabWidth: 4,
                singleQuote: true,
                printWidth: 100,
                endOfLine: 'auto', // Converts windows CRLF line endings to LF.
            },
        ],
    },
    settings: {
        jsdoc: {
            tagNamePreference: {
                param: 'arg',
                returns: 'return',
                ignore: false,
                todo: {
                    message: 'What you put off for tomorrow has now become today.',
                },
            },
        },
    },
};
