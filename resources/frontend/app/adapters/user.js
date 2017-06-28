import DS from "ember-data";
import Ember from 'ember';

export default DS.Adapter.extend({
  query(modelName, query) {
    return Ember.$.getJSON(`/api/users?page=1`);
  },
  queryRecord(modelName, query) {
    console.log(query);
    console.log(modelName);
    debugger;
    return Ember.$.getJSON(`/api/users/${query.id}`);
  }
});
