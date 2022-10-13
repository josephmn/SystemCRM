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
    public class CTipoTrabajador
    {
        public List<ETipoTrabajador> Listar_TipoTrabajador(SqlConnection con)
        {
            List<ETipoTrabajador> lETipoTrabajador = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_TIPOTRABAJADOR", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lETipoTrabajador = new List<ETipoTrabajador>();

                ETipoTrabajador obETipoTrabajador = null;
                while (drd.Read())
                {
                    obETipoTrabajador = new ETipoTrabajador();
                    obETipoTrabajador.i_id = drd["i_id"].ToString();
                    obETipoTrabajador.v_descripcion = drd["v_descripcion"].ToString();
                    obETipoTrabajador.v_default = drd["v_default"].ToString();
                    lETipoTrabajador.Add(obETipoTrabajador);
                }
                drd.Close();
            }

            return (lETipoTrabajador);
        }
    }
}