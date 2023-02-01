<p>To add a file to a project, call the <code>AddProjectFile</code> method with the project ID, file name, and file content.</p>

<div class="section-example-container">
    <pre class="csharp">var response = api.AddProjectFile(projectId, fileName, content);</pre>
    <pre class="python">response = api.AddProjectFile(project_id, file_name, content)</pre>
</div>

<?php include(DOCS_RESOURCES."/qc-api/get-project-id-in-research.html"); ?>

<p>The <code>AddProjectFile</code> method returns a <code>ProjectFilesResponse</code> object, which have the following attributes:</p>
<div data-tree='QuantConnect.Api.ProjectFilesResponse'></div>