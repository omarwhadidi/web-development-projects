const mysql = require('mysql2')
const query = mysql.createConnection({

    host:'localhost',
    user:'root',
    password:'',
    database:'pentest'

})

module.exports = query