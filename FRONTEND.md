# FRONTEND

A few handy considerations about the frontend, blade directives, and more.

### Blade directives


#### @role($role)

You can use a _string_ or an _array of strings_ if you want to check if the authenticated user has a role.

```
@role('user')
  <p>Si ves este mensaje, es proque tenes el rol de <code>user</code>!<p>
@else
  <p>Si ves este mensaje, es porque no tenes el rol de <code>user</code>!<p>
@endrole
```

```
@role(['user','admin'])
  <p>Si ves este mensaje, es proque <b>tenes</b> alguno de estos roles: <code>user</code>, <code>admin</code> !<p>
@else
  <p>Si ves este mensaje, es porque no tenes alguno de estos roles: <code>user</code>, <code>admin</code>!<p>
@endrole
```

#### @isMember

```
/**
* Returns TRUE if the current user is a Member of the objective
* or if it is an user with role admin 
*
* $objectiveId: And id of the objective
*/
@isMember($objectiveId)
  <button>Edit</button>
@endisMember
```

#### @isManager

```
/**
* Returns TRUE if the current user is a Manager of the objective
* or if it is an user with role admin 
*
* $objectiveId: And id of the objective
*/

@isManager($objectiveId)
<button>Edit</button>
@endisManager
```

#### @isReporter

```
/**
* Returns TRUE if the current user is a Reporter of the objective
* or if it is an user with role admin 
*
* $objectiveId: And id of the objective
*/

@isReporter($objectiveId)
<button>Edit</button>
@endisReporter
```

#### @isOnlyMember

```
/**
* Returns TRUE if the current user is only a Member of the objective.
* No matter if the current user has the "admin" role.
*
* $objectiveId: And id of the objective
*/

@isOnlyMember($objectiveId)
<button>Edit</button>
@endisOnlyMember
```

#### @isOnlyManager

```
/**
* Returns TRUE if the current user is only a Manager of the objective.
* No matter if the current user has the "admin" role.
*
* $objectiveId: And id of the objective
*/

@isOnlyManager($objectiveId)
<button>Edit</button>
@endisOnlyManager
```

#### @isOnlyReporter

```
/**
* Returns TRUE if the current user is only a Reporter of the objective.
* No matter if the current user has the "admin" role.
*
* $objectiveId: And id of the objective
*/

@isOnlyReporter($objectiveId)
<button>Edit</button>
@endisOnlyReporter
```

#### @datetime($date)

```
/**
* Returns the date in format YYYY-MM-DD HH:II
*
* $date: A Carbon datetime instance
*/

@datetime(Carbon\Carbon $date)
```

#### @justdate($date)

```
/**
* Returns the date in format YYYY-MM-DD
*
* $date: A Carbon datetime instance
*/

@justdate(Carbon\Carbon $date)
```