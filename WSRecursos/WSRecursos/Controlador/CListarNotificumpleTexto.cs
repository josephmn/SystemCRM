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
    public class CListarNotificumpleTexto
    {
        public List<EListarNotificumpleTexto> ListarNotificumpleTexto(SqlConnection con, Int32 id)
        {
            List<EListarNotificumpleTexto> lEListarNotificumpleTexto = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_NOFITICUMPLEANIOS_TEXTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarNotificumpleTexto = new List<EListarNotificumpleTexto>();

                EListarNotificumpleTexto obEListarNotificumpleTexto = null;
                while (drd.Read())
                {
                    obEListarNotificumpleTexto = new EListarNotificumpleTexto();
                    obEListarNotificumpleTexto.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarNotificumpleTexto.i_notifi = Convert.ToInt32(drd["i_notifi"].ToString());
                    obEListarNotificumpleTexto.v_texto = drd["v_texto"].ToString();
                    obEListarNotificumpleTexto.i_tamanio = Convert.ToInt32(drd["i_tamanio"].ToString());
                    obEListarNotificumpleTexto.v_color = drd["v_color"].ToString();
                    obEListarNotificumpleTexto.i_angulo = Convert.ToInt32(drd["i_angulo"].ToString());
                    obEListarNotificumpleTexto.i_posicionx = Convert.ToInt32(drd["i_posicionx"].ToString());
                    obEListarNotificumpleTexto.i_posiciony = Convert.ToInt32(drd["i_posiciony"].ToString());
                    obEListarNotificumpleTexto.i_alineacion = drd["i_alineacion"].ToString();
                    obEListarNotificumpleTexto.v_fuente = drd["v_fuente"].ToString();
                    lEListarNotificumpleTexto.Add(obEListarNotificumpleTexto);
                }
                drd.Close();
            }

            return (lEListarNotificumpleTexto);
        }
    }
}