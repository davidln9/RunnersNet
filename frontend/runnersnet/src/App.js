import React from 'react';
import { Provider } from 'react-redux';
import { store, history } from './redux/store';
import MainRouter from './MainRouter'


class App extends React.Component {

    render() {
        return (
            <Provider store={store}>
                <MainRouter history={history} />
            </Provider>
        );
    }
}

export default App;
