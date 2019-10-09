<script type="text/javascript">
  window.App = {
    user: JSON.parse('@json(auth()->user())'),
    signedIn: JSON.parse('{{ auth()->check() }}'),
  };
</script>
