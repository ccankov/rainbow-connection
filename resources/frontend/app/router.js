import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType,
  rootURL: config.rootURL
});

Router.map(function() {
  // Map frontend routes
  this.route('initial', { path: '/' });
  this.route('user', { path: '/:id' });
});

export default Router;
