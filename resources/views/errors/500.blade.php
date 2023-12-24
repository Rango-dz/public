<div class="content">
    <div class="title">Something went wrong.</div>
  
    @if(app()->bound('sentry') && app('sentry')->getLastEventId())
    <div class="subtitle">Error ID: {{ app('sentry')->getLastEventId() }}</div>
    <script>
      Sentry.init({ dsn: 'https://b39646a3345041b8a089bbd5560e3661@o1381891.ingest.sentry.io/4504707173187584' });
      Sentry.showReportDialog({
        eventId: '{{ app('sentry')->getLastEventId() }}'
      });
    </script>
    @endif
  </div>