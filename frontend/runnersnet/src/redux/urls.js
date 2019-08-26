const BASE = "http://localhost:8080"
const API = BASE + "/api"
const USER_API = API + "/user"
const ADMIN = BASE + "/admin"
const LOGIN = BASE + "/login"
const REGISTER_USER = USER_API + "/register"

const urls = {
    API: API,
    BASE: BASE,
    USER_API:  USER_API,
    ADMIN: ADMIN,
    LOGIN: LOGIN,
    REGISTER_USER: REGISTER_USER
}

export default urls;