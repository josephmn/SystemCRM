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
    public class CListarPaNotificaciones
    {
        public List<EListarPaNotificaciones> ListarPaNotificaciones(SqlConnection con, Int32 post, Int32 top, String dni)
        {
            List<EListarPaNotificaciones> lEListarPaNotificaciones = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_PANOTIFICACIONES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@top", SqlDbType.Int).Value = top;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarPaNotificaciones = new List<EListarPaNotificaciones>();

                EListarPaNotificaciones obEListarPaNotificaciones = null;
                while (drd.Read())
                {
                    obEListarPaNotificaciones = new EListarPaNotificaciones();
                    obEListarPaNotificaciones.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarPaNotificaciones.v_class = drd["v_class"].ToString();
                    obEListarPaNotificaciones.v_title = drd["v_title"].ToString();
                    obEListarPaNotificaciones.v_subtitle = drd["v_subtitle"].ToString();
                    obEListarPaNotificaciones.v_body = drd["v_body"].ToString();
                    obEListarPaNotificaciones.v_description = drd["v_description"].ToString();
                    obEListarPaNotificaciones.i_autohide = Convert.ToBoolean(drd["i_autohide"].ToString());
                    obEListarPaNotificaciones.i_delay = Convert.ToInt32(drd["i_delay"].ToString());
                    obEListarPaNotificaciones.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarPaNotificaciones.v_estado = drd["v_estado"].ToString();
                    obEListarPaNotificaciones.v_estado_color = drd["v_estado_color"].ToString();
                    obEListarPaNotificaciones.d_crtd_date = drd["d_crtd_date"].ToString();
                    obEListarPaNotificaciones.v_link = drd["v_link"].ToString();
                    lEListarPaNotificaciones.Add(obEListarPaNotificaciones);
                }
                drd.Close();
            }

            return (lEListarPaNotificaciones);
        }
    }
}