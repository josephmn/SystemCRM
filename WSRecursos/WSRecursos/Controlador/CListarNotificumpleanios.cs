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
    public class CListarNotificumpleanios
    {
        public List<EListarNotificumpleanios> ListarNotificumpleanios(SqlConnection con, Int32 post, Int32 id)
        {
            List<EListarNotificumpleanios> lEListarNotificumpleanios = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_NOTIFICUMPLEANIOS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarNotificumpleanios = new List<EListarNotificumpleanios>();

                EListarNotificumpleanios obEListarNotificumpleanios = null;
                while (drd.Read())
                {
                    obEListarNotificumpleanios = new EListarNotificumpleanios();
                    obEListarNotificumpleanios.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarNotificumpleanios.v_nombre = drd["v_nombre"].ToString();
                    obEListarNotificumpleanios.v_ventana = drd["v_ventana"].ToString();
                    obEListarNotificumpleanios.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarNotificumpleanios.v_estado = drd["v_estado"].ToString();
                    obEListarNotificumpleanios.v_color_estado = drd["v_color_estado"].ToString();
                    obEListarNotificumpleanios.i_condicion = Convert.ToInt32(drd["i_condicion"].ToString());
                    obEListarNotificumpleanios.v_condicion = drd["v_condicion"].ToString();
                    obEListarNotificumpleanios.v_none_texto = drd["v_none_texto"].ToString();
                    obEListarNotificumpleanios.v_class = drd["v_class"].ToString();
                    obEListarNotificumpleanios.v_href = drd["v_href"].ToString();
                    obEListarNotificumpleanios.v_target = drd["v_target"].ToString();
                    obEListarNotificumpleanios.v_none_imagen = drd["v_none_imagen"].ToString();
                    obEListarNotificumpleanios.v_none_pdf = drd["v_none_pdf"].ToString();
                    obEListarNotificumpleanios.v_icon = drd["v_icon"].ToString();
                    obEListarNotificumpleanios.v_color_icon = drd["v_color_icon"].ToString();
                    lEListarNotificumpleanios.Add(obEListarNotificumpleanios);
                }
                drd.Close();
            }

            return (lEListarNotificumpleanios);
        }
    }
}