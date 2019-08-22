const express = require('express')
const history = require('connect-history-api-fallback')
const serveStatic = require('serve-static')
const port = process.env.PORT || 8080

const app = express()

app.use(history())
app.use(serveStatic(__dirname + "/dist"));

app.listen(port, () => {
  console.log('server started ' + port)
})
