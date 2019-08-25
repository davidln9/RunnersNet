import React from 'react';
import { connect } from 'react-redux'
import { BrowserRouter as Router, Route, Switch } from "react-router-dom";

// components
import Login from './components/Login';
import NotFound from './components/NotFound';
import Signup from './components/Signup';

class MainRouter extends React.Component {


    render() {
        return (
            <Router>
                <Switch>
                    <Route path="/login" component={Login} />
                    <Route path="/signup" component={Signup} />
                    <Route component={NotFound}/>
                </Switch>
            </Router>
        )
    }
}

function mapStateToProps(state) {
    let loggedin = true;
    if (localStorage.getItem('jwt') === null || localStorage.getItem('jwt') === "") {
        loggedin = false;
    }

    return ({
        loggedin: loggedin
    })
}

export default connect(mapStateToProps)(MainRouter)