
import usersInfo from '../pages/information.vue'
import userDetails from '../pages/userDetails.vue'
import profile from '../pages/profile.vue'



const routes = [
    {path : '/users-details/:id', component: userDetails, name: 'users-details'},
    {path : '/users-info', component: usersInfo, name: 'users-info'},
    {path : '/profile', component: profile, name: 'profile'},

]

export default routes
