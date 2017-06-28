import DS from "ember-data";
import Ember from 'ember';

export default DS.Adapter.extend({
  query(modelName, query) {
    return Ember.$.getJSON(`/api/users?page=1`);
  }
});
