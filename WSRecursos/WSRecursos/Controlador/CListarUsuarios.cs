using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CListarUsuarios
    {
        public List<EListarUsuarios> Listar_ListarUsuarios(SqlConnection con, Int32 post, String dni, Int32 estado)
        {
            List<EListarUsuarios> lEListarUsuarios = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_USUARIOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@estado", SqlDbType.Int).Value = estado;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarUsuarios = new List<EListarUsuarios>();

                EListarUsuarios obEListarUsuarios = null;
                while (drd.Read())
                {
                    obEListarUsuarios = new EListarUsuarios();
                    obEListarUsuarios.i_id = drd["i_id"].ToString();
                    obEListarUsuarios.v_dni = drd["v_dni"].ToString();
                    obEListarUsuarios.v_nombre = drd["v_nombre"].ToString();
                    obEListarUsuarios.v_apellidos = drd["v_apellidos"].ToString();
                    obEListarUsuarios.v_celular = drd["v_celular"].ToString();
                    obEListarUsuarios.v_correo = drd["v_correo"].ToString();
                    obEListarUsuarios.i_estado = drd["i_estado"].ToString();
                    obEListarUsuarios.v_estado = drd["v_estado"].ToString();
                    obEListarUsuarios.v_color_estado = drd["v_color_estado"].ToString();
                    obEListarUsuarios.i_perfil = drd["i_perfil"].ToString();
                    obEListarUsuarios.v_perfil = drd["v_perfil"].ToString();
                    obEListarUsuarios.v_foto = drd["v_foto"].ToString();
                    lEListarUsuarios.Add(obEListarUsuarios);
                }
                drd.Close();
            }

            return (lEListarUsuarios);
        }
    }
}