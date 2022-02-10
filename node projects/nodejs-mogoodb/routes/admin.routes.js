const AdminRouter = require('express').Router()
const AdminContr = require('../controller/admin.contr')

AdminRouter.get('/admin', AdminContr.adminpage);

AdminRouter.get('/dashboard', AdminContr.dashboardpage);



AdminRouter.post('/UpgradeUser', AdminContr.upgradeuser);

AdminRouter.post('/DowngradeUser', AdminContr.downgradeuser);

AdminRouter.post('/ActivateUser', AdminContr.activateuser);

AdminRouter.post('/DeactivateUser',  AdminContr.deactivateuser);

AdminRouter.post('/DeleteUser', AdminContr.deleteuser);


module.exports = AdminRouter