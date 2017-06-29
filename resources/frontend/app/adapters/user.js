import DS from "ember-data";
import Ember from 'ember';

export default DS.JSONAPIAdapter.extend({
  namespace: 'api',
  deleteConnection(user_id, connection_id) {
    return Ember.$.getJSON(`api/users/${user_id}/${connection_id}`);
  }
});
