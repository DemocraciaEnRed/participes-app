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