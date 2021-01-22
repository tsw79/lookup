/**
 * Created by PhpChassis.
 * User: tharwat
 * Date: 17/1/2020
 * Time: 3:21
 */

/* Ref: https://ultimatecourses.com/blog/attaching-event-handlers-to-dynamically-created-javascript-elements */
const doc = document;
const _$ = doc.querySelector.bind(doc);       // Single elements
const _$$ = doc.querySelectorAll.bind(doc);   // Multiple elements

var _$id = function (id) {
    return doc.getElementById(id);
};