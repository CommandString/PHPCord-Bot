const nodemon = require('nodemon');

class DiscordBotWatcher {
    static start() {
        nodemon({
            exec: 'php start.php',
            ext: 'php',
            ignore: ['node_modules', 'vendor']
        })
    }
}
