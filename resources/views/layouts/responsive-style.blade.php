<style>
  :root{
    --app-max-width: 1440px;
    --sidebar-width: 320px;
    --primary:#0B7F6F;
    --primary-dark:#0B5B6B;
    --soft-border:rgba(0,0,0,.06);
    --soft-shadow:0 12px 28px rgba(2, 6, 23, .08);
  }

  *{ box-sizing:border-box; }

  html, body{
    width:100%;
    overflow-x:hidden;
  }

  body{
    font-family:'Prompt',system-ui,sans-serif;
  }

  .app-bg{
    background:linear-gradient(135deg,#CFEFF3 0%,#DFF7EF 50%,#F0F8FB 100%);
    min-height:100vh;
  }

  .page-shell{
    width:100%;
    max-width:var(--app-max-width);
    margin:0 auto;
  }

  .main-grid{
    display:grid;
    grid-template-columns: var(--sidebar-width) 1fr;
    gap:1rem;
    align-items:start;
  }

  .content-area{
    min-width:0;
  }

  .sidebar{
    width:100%;
    position:sticky;
    top:74px;
    height:calc(100vh - 90px);
    overflow:auto;
  }

  .shadow-soft{
    box-shadow:var(--soft-shadow)!important;
  }

  .nav-pills .nav-link{
    border-radius:14px;
    padding:10px 12px;
  }

  .nav-pills .nav-link.active{
    background:var(--primary)!important;
  }

  .kpi-icon{
    width:46px;
    height:46px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:16px;
    flex-shrink:0;
  }

  .chip{
    border-radius:999px;
    padding:.35rem .7rem;
    font-size:.85rem;
    display:inline-flex;
    align-items:center;
    gap:.4rem;
    border:1px solid rgba(0,0,0,.08);
    background:#fff;
  }

  .dropdown-menu-scrollable{
    max-height:260px;
    overflow:auto;
  }

  .page-title{
    font-size:clamp(1.1rem, 1vw + .8rem, 1.45rem);
    line-height:1.35;
  }

  .section-title{
    font-size:clamp(.95rem, .5vw + .8rem, 1.05rem);
    line-height:1.35;
  }

  .kpi-number{
    font-size:clamp(1.5rem, .8vw + 1rem, 2rem);
    line-height:1.1;
  }

  .text-primary-soft{
    color:var(--primary)!important;
  }

  .text-primary-dark{
    color:var(--primary-dark)!important;
  }

  .bg-soft-green{
    background:rgba(11,127,111,.08)!important;
  }

  .bg-soft-border{
    border-color:var(--soft-border)!important;
  }

  .chart-wrap{
    width:100%;
    position:relative;
  }

  .chart-health{ height:380px; }
  .chart-donut{ width:250px; height:250px; margin:auto; }
  .chart-trend{ height:260px; }
  .chart-radar{ height:320px; }

  .table-soft{
    border-radius:14px;
    overflow:hidden;
    border:1px solid var(--soft-border);
  }

  .row-hover{
    transition:.15s;
  }

  .row-hover:hover{
    background:rgba(11,127,111,.05);
  }

  .card{
    box-shadow:var(--soft-shadow);
  }

  @media (max-width: 991.98px){
    .main-grid{
      grid-template-columns:1fr;
    }

    .sidebar-desktop{
      display:none!important;
    }
  }

  @media (max-width: 767.98px){
    .page-shell{
      padding:0 12px;
    }

    .chart-health{ height:300px; }
    .chart-donut{ width:220px; height:220px; }
    .chart-trend{ height:220px; }
    .chart-radar{ height:260px; }
  }
</style>