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
    public class CListarDisenioNotificumpleTexto
    {
        public List<EListarDisenioNotificumpleTexto> ListarDisenioNotificumpleTexto(SqlConnection con, Int32 id)
        {
            List<EListarDisenioNotificumpleTexto> lEListarDisenioNotificumpleTexto = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_DISENIO_NOTIFICUMPLEANIO_TEXTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarDisenioNotificumpleTexto = new List<EListarDisenioNotificumpleTexto>();

                EListarDisenioNotificumpleTexto obEListarDisenioNotificumpleTexto = null;
                while (drd.Read())
                {
                    obEListarDisenioNotificumpleTexto = new EListarDisenioNotificumpleTexto();
                    obEListarDisenioNotificumpleTexto.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarDisenioNotificumpleTexto.i_notifi = Convert.ToInt32(drd["i_notifi"].ToString());
                    obEListarDisenioNotificumpleTexto.v_texto = drd["v_texto"].ToString();
                    obEListarDisenioNotificumpleTexto.i_tamanio = Convert.ToInt32(drd["i_tamanio"].ToString());
                    obEListarDisenioNotificumpleTexto.v_color = drd["v_color"].ToString();
                    obEListarDisenioNotificumpleTexto.i_angulo = Convert.ToInt32(drd["i_angulo"].ToString());
                    obEListarDisenioNotificumpleTexto.i_posicionx = Convert.ToInt32(drd["i_posicionx"].ToString());
                    obEListarDisenioNotificumpleTexto.i_posiciony = Convert.ToInt32(drd["i_posiciony"].ToString());
                    obEListarDisenioNotificumpleTexto.i_alineacion = Convert.ToInt32(drd["i_alineacion"].ToString());
                    obEListarDisenioNotificumpleTexto.v_fuente = drd["v_fuente"].ToString();
                    lEListarDisenioNotificumpleTexto.Add(obEListarDisenioNotificumpleTexto);
                }
                drd.Close();
            }

            return (lEListarDisenioNotificumpleTexto);
        }
    }
}