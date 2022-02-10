const AdminRouter = require("express").Router()
const AdminContr = require('../controller/admin.contr') 



AdminRouter.get('/admin', AdminContr.adminpage)

AdminRouter.get('/dashboard', AdminContr.dashboard)

AdminRouter.get('/GetUsersDetails', AdminContr.getusersdetails)

AdminRouter.get('/GetUserDetails/:user', AdminContr.getuserdetails)


AdminRouter.post('/AddPost', AdminContr.addpost)

AdminRouter.post('/DeletePost', AdminContr.deletepost)


AdminRouter.post('/UpgradeUser', AdminContr.upgradeuser)

AdminRouter.post('/DowngradeUser', AdminContr.downgradeuser)

AdminRouter.post('/ActivateUser', AdminContr.activateuser)

AdminRouter.post('/DeactivateUser', AdminContr.deactivateuser)

AdminRouter.post('/DeleteUser', AdminContr.deleteuser)



module.exports = AdminRouter