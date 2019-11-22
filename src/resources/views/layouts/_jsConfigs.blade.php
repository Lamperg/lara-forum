<script type="text/javascript">
  window.App = {
    user: JSON.parse('@json(auth()->user())'),
    signedIn: JSON.parse('@json(auth()->check())'),
  };
</script>
