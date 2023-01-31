<p>Intellisense is a GUI tool in your code files that shows auto-completion options and presents the members that are accessible from the current object. The tool works by searching for the statement that you're typing, given the context. You can use Intellisense to auto-complete method names and object attributes. When you use it, a pop-up displays in the IDE with the following information:</p>

<ul>
    <li>Member type</li>
    <li>Member description</li>
    <li>The parameters that the method accepts (if the member is a method)</li>
</ul>

<p>Use Intellisense to speed up your algorithm development. It works with all of the default class members in Lean, but it doesn't currently support class names or user-defined objects. <?=$localPlatformOrCli ? "Local auto-complete is also available for <a href='/docs/v2/lean-cli/projects/autocomplete'>select IDEs</a>." : "" ?></p>
