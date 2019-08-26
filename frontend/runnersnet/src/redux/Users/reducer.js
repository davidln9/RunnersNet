import { actions } from './actions';


const initialState = {
    loggedin: false,
    message: ""
}

export default function userReducer(state = initialState, action) {
    switch (action.type) {
        case actions.LOGIN_SUCCESS:
            return ({
                    loggedin: true,
                    message: "logged in"
                });
        case actions.LOGIN_FAILURE:
            return ({
                loggedin: false,
                message: action.data
            })
        case actions.REGISTER_SUCCESS:
            return ({
                loggedin: false,
                message: action.data
            })
        default:
            return state;
    }
}