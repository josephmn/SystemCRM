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
    public class CListarDisenioTexto
    {
        public List<EListarDisenioTexto> ListarDisenioTexto(SqlConnection con, Int32 id)
        {
            List<EListarDisenioTexto> lEListarDisenioTexto = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_DISENIO_TEXTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarDisenioTexto = new List<EListarDisenioTexto>();

                EListarDisenioTexto obEListarDisenioTexto = null;
                while (drd.Read())
                {
                    obEListarDisenioTexto = new EListarDisenioTexto();
                    obEListarDisenioTexto.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarDisenioTexto.i_convenio = Convert.ToInt32(drd["i_convenio"].ToString());
                    obEListarDisenioTexto.v_texto = drd["v_texto"].ToString();
                    obEListarDisenioTexto.i_tamanio = Convert.ToInt32(drd["i_tamanio"].ToString());
                    obEListarDisenioTexto.v_color = drd["v_color"].ToString();
                    obEListarDisenioTexto.i_angulo = Convert.ToInt32(drd["i_angulo"].ToString());
                    obEListarDisenioTexto.i_posicionx = Convert.ToInt32(drd["i_posicionx"].ToString());
                    obEListarDisenioTexto.i_posiciony = Convert.ToInt32(drd["i_posiciony"].ToString());
                    lEListarDisenioTexto.Add(obEListarDisenioTexto);
                }
                drd.Close();
            }

            return (lEListarDisenioTexto);
        }
    }
}