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
    public class CTipoContrato
    {
        public List<ETipoContrato> Listar_TipoContrato(SqlConnection con)
        {
            List<ETipoContrato> lETipoContrato = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_TIPOCONTRATO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lETipoContrato = new List<ETipoContrato>();

                ETipoContrato obETipoContrato = null;
                while (drd.Read())
                {
                    obETipoContrato = new ETipoContrato();
                    obETipoContrato.i_id = drd["i_id"].ToString();
                    obETipoContrato.v_descripcion = drd["v_descripcion"].ToString();
                    obETipoContrato.v_default = drd["v_default"].ToString();
                    lETipoContrato.Add(obETipoContrato);
                }
                drd.Close();
            }

            return (lETipoContrato);
        }
    }
}