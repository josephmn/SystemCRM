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
    public class CListarNotificaciones
    {
        public List<EListarNotificaciones> ListarNotificaciones(SqlConnection con, Int32 post, Int32 id)
        {
            List<EListarNotificaciones> lEListarNotificaciones = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_NOTIFICACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarNotificaciones = new List<EListarNotificaciones>();

                EListarNotificaciones obEListarNotificaciones = null;
                while (drd.Read())
                {
                    obEListarNotificaciones = new EListarNotificaciones();
                    obEListarNotificaciones.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarNotificaciones.v_class = drd["v_class"].ToString();
                    obEListarNotificaciones.v_title = drd["v_title"].ToString();
                    obEListarNotificaciones.v_subtitle = drd["v_subtitle"].ToString();
                    obEListarNotificaciones.v_body = drd["v_body"].ToString();
                    obEListarNotificaciones.v_description = drd["v_description"].ToString();
                    obEListarNotificaciones.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarNotificaciones.v_estado = drd["v_estado"].ToString();
                    obEListarNotificaciones.v_estado_color = drd["v_estado_color"].ToString();
                    obEListarNotificaciones.v_crtd_user = drd["v_crtd_user"].ToString();
                    obEListarNotificaciones.d_creacion = drd["d_creacion"].ToString();
                    obEListarNotificaciones.v_lupd_user = drd["v_lupd_user"].ToString();
                    obEListarNotificaciones.d_actualizacion = drd["d_actualizacion"].ToString();
                    obEListarNotificaciones.v_link = drd["v_link"].ToString();
                    lEListarNotificaciones.Add(obEListarNotificaciones);
                }
                drd.Close();
            }

            return (lEListarNotificaciones);
        }
    }
}