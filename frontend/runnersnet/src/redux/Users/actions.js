import axios from 'axios'
import urls from '../urls';

const actions = {
  LOGIN_SUCCESS: "LOGIN_SUCCESS",
  LOGIN_FAILURE: "LOGIN_FAILURE",
  login: (data) => {
    return dispatch => {
      return axios
        .post(urls.LOGIN, {
          username: data.username,
          password: data.password
        })
        .then(response => {
          dispatch({
            type: actions.LOGIN_SUCCESS
          })
          localStorage.setItem('jwt', response.headers.Authorization);
        })
        .catch(error => {
          dispatch({
            type: actions.LOGIN_FAILURE,
            data: error.message
          })
          console.log(error.message);
          throw error;
        })
    }
  },
  REGISTER_SUCCESS: "SIGNUP_SUCCESS",
  REGISTER_FAILURE: "SIGNUP_FAILURE",
  register: data => {
    return dispatch => {
      return axios
      .post(urls.REGISTER_USER, data)
      .then(response=>{
        dispatch({
          type: actions.REGISTER_SUCCESS,
          data: response.headers.message
        })
      })
      .catch(error=>{
        dispatch({
          type: actions.REGISTER_FAILURE,
          data: error.message
        })
        throw error
      })
    }
  }
}

export { actions };