import Ember from 'ember';

export default Ember.Route.extend({
  model(params) {
    debugger;
    return this.get('store').queryRecord('user', params);
  }
});
