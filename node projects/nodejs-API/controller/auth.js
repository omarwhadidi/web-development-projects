const jwt = require('jsonwebtoken')

module.exports = (req,res,next)=> {

    // const token = req.body.token || req.query.token || req.headers["x-access-token"];
    const authHeader = req.headers['authorization']
    const token = authHeader && authHeader.split(' ')[1]  // Send JWT in Authorization header

     jwt.verify(token , "omar" , async (err , decoded)=>{
        
        if (err){
                res.json({err})
        }
        else {
            req.userID = decoded.userid
            req.username = decoded.user
            req.role = decoded.role
            next()
        }
    })

}