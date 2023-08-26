import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
//import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
//import Dashboard from '../pages/Dashboard';

import collectives from '../components/collectives/index';
import showcollective from '../components/collectives/show';
import editcollective from '../components/collectives/edit';
import addcollective from '../components/collectives/create';
import questions from '../components/questions/index';
import showquestion from '../components/questions/show' ;
import editquestion from '../components/questions/edit.vue' ;
import addquestion from '../components/questions/create' ;

// Route::get('questions/{id}/voteup', 'QuestionController@voteUp');
// Route::get('questions/{id}/votedown', 'QuestionController@voteDown');
// Route::get('question/{id}/comments', 'QuestionController@getQuestionComments');
// Route::post('comments/add', 'CommentController@store');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'collectives',
        path: '/collectives',
        component: collectives
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'questions',
        path: '/questions',
        component: questions
    },
    {
        name: 'addquestion',
        path: '/questions/add',
        component: addquestion
    },
    {
        name: 'addcollective',
        path: '/collectives/add',
        component: addcollective
    },
    {
        name: 'editquestion',
        path: '/questions/edit/:id',
        component: editquestion
    },
    {
        name: 'editcollective',
        path: '/collectives/edit/:id',
        component: editcollective
    },
    {
        name: 'showcollective',
        path: '/collectives/show/:id',
        component: showcollective
    },
    {
        name: 'showquestion',
        path: '/questions/show/:id',
        component: showquestion
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
