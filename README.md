# DynamicScoreboard Plugin

---

![GitHub followers](https://img.shields.io/github/followers/imjustnozell) ![GitHub Repo stars](https://img.shields.io/github/stars/imjustnozell/dynamicscoreboard) ![GitHub language count](https://img.shields.io/github/languages/count/imjustnozell/dynamicscoreboard)
![GitHub top language](https://img.shields.io/github/languages/top/imjustnozell/dynamicscoreboard)
![GitHub commit activity](https://img.shields.io/github/commit-activity/t/imjustnozell/dynamicscoreboard)
![GitHub contributors](https://img.shields.io/github/contributors/imjustnozell/dynamicscoreboard)
![GitHub Created At](https://img.shields.io/github/created-at/imjustnozell/dynamicscoreboard)

<table align="center">
<tr border="none">
<td width="50%" align="left">
  
- <img src="https://komarev.com/ghpvc/?username=imjustnozell&label=Profile%20views&color=0e75b6&style=flat" alt="Nozell" /> </p>

- 💻 Passionate about **Arduino Projects, PLC Automation & Web Development**

- <p>
    <a href="https://www.paypal.com/paypalme/vNozell" target="_blank" rel="noopener noreferrer">
      <img src="https://img.shields.io/badge/PayPal-00457C?style=for-the-badge&logo=paypal&logoColor=white" alt="PayPal Badge" />
    </a>
  </p>

- <p>
    <a href="mailto:imjustnozell@gmail.com" target="_blank" rel="noopener noreferrer">
      <img src="https://img.shields.io/badge/Gmail-D14836?style=for-the-badge&logo=gmail&logoColor=white" alt="Gmail Badge" />
    </a>
  </p>

- <p>
  <a href="https://github.com/ImJustNozell" target="_blank" rel="noopener noreferrer">
    <img src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white" alt="GitHub Badge" />
  </a>

  <img src="https://img.shields.io/github/stars/imjustnozell?style=for-the-badge" alt="GitHub User's stars" />

  <img src="https://img.shields.io/github/followers/imjustnozell?style=for-the-badge" alt="GitHub followers" />

</p>

- <p>
  <a href="https://www.youtube.com/channel/UCg4BM8oOB_kP9c6lz3fvLng" target="_blank" rel="noopener noreferrer">
    <img src="https://img.shields.io/badge/YouTube-FF0000?style=for-the-badge&logo=youtube&logoColor=white" alt="YouTube Badge" />
  </a>

  <img src="https://img.shields.io/youtube/channel/subscribers/UCg4BM8oOB_kP9c6lz3fvLng?style=for-the-badge" alt="YouTube Subscribers" />

  <img src="https://img.shields.io/youtube/channel/views/UCg4BM8oOB_kP9c6lz3fvLng?style=for-the-badge" alt="YouTube Views" />

</p>

</td>
<td width="50%" align="center">

<img src="https://metrics.lecoq.io/imjustnozell?template=classic&achievements=1&achievements.threshold=C&achievements.secrets=true&achievements.display=compact&achievements.limit=0&config.timezone=America%2FLima" alt="Metrics for imjustnozell">

  </td>
</tr>
</table>

---

**DynamicScoreboard** es un plugin que permite a los jugadores crear y editar _scoreboards_ de manera fácil y dinámica dentro de su servidor de Minecraft.

---

**DynamicScoreboard** is a plugin that allows players to easily create and edit _scoreboards_ dynamically within their Minecraft server.

---

## Comandos disponibles / Available Commands

### 1. `/score create`

Este comando te permite crear un _scoreboard_.

**Uso:**

```
/score create
```

Al ejecutar este comando, se abrirá un formulario para crear un nuevo _scoreboard_. En este formulario podrás personalizar el título y agregar hasta 15 líneas de texto.

---

This command allows you to create a _scoreboard_.

**Usage:**

```
/score create
```

When you run this command, a form will open to create a new _scoreboard_. In this form, you can customize the title and add up to 15 lines of text.

---

### 2. `/score edit`

Este comando te permite editar un _scoreboard_ existente.

**Uso:**

```
/score edit
```

Al ejecutar este comando, se abrirá un formulario donde podrás modificar el título y las líneas de un _scoreboard_ existente.

---

This command allows you to edit an existing _scoreboard_.

**Usage:**

```
/score edit
```

When you run this command, a form will open where you can modify the title and lines of an existing _scoreboard_.

---

## Funcionalidades del _Scoreboard_ / _Scoreboard_ Features

- Puedes personalizar el título del _scoreboard_.
- Hasta 15 líneas disponibles para editar con información personalizada.
- Variables disponibles para usar dentro de las líneas:
  - `{date}`: Muestra la fecha actual.
  - `{tps}`: Muestra el rendimiento del servidor (Ticks Per Second).
  - `{world}`: Nombre del mundo actual del jugador.
  - `{player_name}`: Nombre del jugador.
  - `{player_ping}`: Ping del jugador.
  - `{players_online}`: Número de jugadores conectados en el servidor.

---

- You can customize the _scoreboard_ title.
- Up to 15 lines available for custom information.
- Variables available for use within the lines:
  - `{date}`: Displays the current date.
  - `{tps}`: Displays server performance (Ticks Per Second).
  - `{world}`: Displays the player’s current world name.
  - `{player_name}`: Displays the player's name.
  - `{player_ping}`: Displays the player's ping.
  - `{players_online}`: Displays the number of online players.

---

## Instalación / Installation

1. Descarga el plugin **DynamicScoreboard**.
2. Coloca el archivo `.phar` en la carpeta `plugins` de tu servidor.
3. Reinicia el servidor para activar el plugin.

---

1. Download the **DynamicScoreboard** plugin.
2. Place the `.phar` file into your server’s `plugins` folder.
3. Restart the server to activate the plugin.

---

## Librerías requeridas / Required Libraries

Para que **DynamicScoreboard** funcione correctamente, se requieren las siguientes librerías:

1. **YamlProvider**: Esta librería permite el manejo de archivos YAML para almacenar y recuperar configuraciones de manera eficiente.

   - Repositorio: [YamlProvider](https://github.com/ImJustNozell/YamlProvider)

2. **FormsUI**: Esta librería proporciona interfaces gráficas personalizadas que permiten a los jugadores interactuar con formularios en el juego.
   - Repositorio: [FormsUI](https://github.com/ImJustNozell/FormsUI)

---

For **DynamicScoreboard** to function properly, the following libraries are required:

1. **YamlProvider**: This library allows for efficient YAML file management to store and retrieve configurations.

   - Repository: [YamlProvider](https://github.com/ImJustNozell/YamlProvider)

2. **FormsUI**: This library provides custom graphical interfaces that allow players to interact with in-game forms.
   - Repository: [FormsUI](https://github.com/ImJustNozell/FormsUI)

---

## Configuración / Configuration

Este plugin utiliza archivos de configuración en formato YAML para almacenar las _scoreboards_. Los archivos de configuración se guardan en el directorio de datos del plugin.

Una vez que creas o editas un _scoreboard_, los cambios se aplican automáticamente sin necesidad de recargar el servidor.

---

This plugin uses YAML configuration files to store _scoreboards_. The configuration files are stored in the plugin’s data directory.

Once you create or edit a _scoreboard_, changes are applied automatically without the need to reload the server.

---
